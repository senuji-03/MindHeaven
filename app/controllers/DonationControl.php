<?php

class DonationControl
{

    // Fallback index
    // Redirect to home page fundraising section
    public function index()
    {
        $eventId = isset($_GET['event_id']) ? $_GET['event_id'] : null;
        if ($eventId) {
            // If they are trying to donate to a specific event via query param, redirect to the correct route
            header('Location: ' . BASE_URL . '/donation/event/' . $eventId);
            exit;
        }

        // Otherwise redirect to the fundraising events section on home page
        header('Location: ' . BASE_URL . '/#fundraising-events');
        exit;
    }

    // Show donation form for a specific event
    public function showEventDonationForm($eventId = null)
    {
        if (!$eventId) {
            $_SESSION['error'] = 'Event ID is required.';
            header('Location: ' . BASE_URL);
            exit;
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM university_rep_events WHERE id = ? AND status = 'approved'");
        $stmt->execute(array($eventId));
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            $_SESSION['error'] = 'Invalid or unapproved event for donation.';
            header('Location: ' . BASE_URL);
            exit;
        }

        view('donation/event-form', array('event' => $event));
    }

    public function startPayHereCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $amount = isset($_POST['amount']) ? (float) $_POST['amount'] : 0;
        $eventId = isset($_POST['event_id']) ? $_POST['event_id'] : null;
        $donorMessage = trim(isset($_POST['donor_message']) ? $_POST['donor_message'] : '');

        if (!$eventId || $amount <= 0) {
            $_SESSION['error'] = 'Invalid donation amount or event.';
            header('Location: ' . BASE_URL . "/donation/event/$eventId");
            exit;
        }

        require_once BASE_PATH . '/app/models/Donation.php';

        $isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);

        $donorId = $isLoggedIn ? (int) $_SESSION['user_id'] : null;
        $donorName = trim(isset($_POST['donor_name']) ? $_POST['donor_name'] : '');
        $donorEmail = trim(isset($_POST['donor_email']) ? $_POST['donor_email'] : '');
        $donorPhone = trim(isset($_POST['donor_phone']) ? $_POST['donor_phone'] : '');

        if ($isLoggedIn) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT full_name, email FROM users WHERE id = ?");
            $stmt->execute(array($donorId));
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $donorName = trim($user['full_name'] ?? '');
            $donorEmail = trim($user['email'] ?? '');
            $donorPhone = $donorPhone !== '' ? $donorPhone : '0771234567';
        } else {
            if ($donorName === '' || $donorEmail === '' || $donorPhone === '') {
                $_SESSION['error'] = 'Name, email, and phone are required for guest donations.';
                header('Location: ' . BASE_URL . "/donation/event/$eventId");
                exit;
            }
        }

        $transactionId = Donation::generateUniqueTransactionId();

        $donationData = array(
            'donor_id' => $donorId,
            'donor_name' => $donorName,
            'donor_email' => $donorEmail,
            'donor_phone' => $donorPhone,
            'amount' => $amount,
            'currency' => 'LKR',
            'transaction_id' => $transactionId,
            'donor_message' => $donorMessage,
            'event_id' => $eventId
        );

        Donation::createPendingDonation($donationData);

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT event_title FROM university_rep_events WHERE id = ?");
        $stmt->execute(array($eventId));
        $eventTitle = $stmt->fetchColumn() ?: "University Event Donation";

        $merchantId = '1235062';
        $merchantSecret = 'MTIyNDc5NzA1NDE2NDExNTY5OTkzNDk0Mzc3MDg0MTAxODg0ODU4Ng==';

        $formattedAmount = number_format($amount, 2, '.', '');
        $currency = 'LKR';

        $hash = strtoupper(
            md5(
                $merchantId .
                $transactionId .
                $formattedAmount .
                $currency .
                strtoupper(md5($merchantSecret))
            )
        );

        $nameParts = preg_split('/\s+/', trim($donorName));
        $firstName = !empty($nameParts[0]) ? $nameParts[0] : 'Guest';
        $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : 'Donor';

        $checkoutData = array(
            'sandbox' => true,
            'merchant_id' => $merchantId,
            'return_url' => BASE_URL . '/donation/payhere/return?order_id=' . urlencode($transactionId),
            'cancel_url' => BASE_URL . '/donation/payhere/cancel?order_id=' . urlencode($transactionId),
            'notify_url' => BASE_URL . '/donation/payhere/notify',
            'order_id' => $transactionId,
            'items' => 'Donation: ' . $eventTitle,
            'currency' => $currency,
            'amount' => $formattedAmount,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $donorEmail !== '' ? $donorEmail : 'guest@example.com',
            'phone' => $donorPhone !== '' ? $donorPhone : '0771234567',
            'address' => 'Not Provided',
            'city' => 'Colombo',
            'country' => 'Sri Lanka',
            'hash' => $hash,
            'custom_1' => (string) $eventId,
            'custom_2' => 'mindheaven_event_donation'
        );

        view('donation/payhere-checkout', array('checkoutData' => $checkoutData));
    }
    public function payhereReturn()
    {
        $transactionId = isset($_GET['order_id']) ? $_GET['order_id'] : null;

        if (!$transactionId) {
            $_SESSION['error'] = 'Invalid return request.';
            header('Location: ' . BASE_URL);
            exit;
        }

        require_once BASE_PATH . '/app/models/Donation.php';

        $donation = Donation::getByTransactionId($transactionId);

        if (!$donation) {
            $_SESSION['error'] = 'Donation record not found.';
            header('Location: ' . BASE_URL);
            exit;
        }

        Donation::updateReturnStatus($transactionId, 'returned');

        $donation = Donation::getByTransactionId($transactionId);

        view('donation/return', array(
            'transactionId' => $transactionId,
            'donation' => $donation
        ));
    }

    public function payhereCancel()
    {
        $transactionId = $_GET['order_id'] ?? null;

        if (!$transactionId) {
            $_SESSION['error'] = 'Invalid cancel request.';
            header('Location: ' . BASE_URL);
            exit;
        }

        require_once BASE_PATH . '/app/models/Donation.php';

        $donation = Donation::getByTransactionId($transactionId);

        if (!$donation) {
            $_SESSION['error'] = 'Donation record not found.';
            header('Location: ' . BASE_URL);
            exit;
        }

        Donation::updateReturnStatus($transactionId, 'cancelled');

        Donation::updateGatewayResponse($transactionId, array(
            'payment_status' => 'failed',
            'gateway_payment_id' => null,
            'gateway_status_code' => '-1',
            'gateway_status_message' => 'Payment cancelled by user',
            'gateway_method' => null
        ));

        view('donation/cancel', array(
            'transactionId' => $transactionId
        ));
    }

    public function payhereNotify()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Method Not Allowed';
            exit;
        }

        $merchantId = isset($_POST['merchant_id']) ? $_POST['merchant_id'] : '';
        $orderId = isset($_POST['order_id']) ? $_POST['order_id'] : '';
        $paymentId = isset($_POST['payment_id']) ? $_POST['payment_id'] : null;
        $payhereAmount = isset($_POST['payhere_amount']) ? $_POST['payhere_amount'] : '';
        $payhereCurrency = isset($_POST['payhere_currency']) ? $_POST['payhere_currency'] : '';
        $statusCode = isset($_POST['status_code']) ? $_POST['status_code'] : '';
        $method = isset($_POST['method']) ? $_POST['method'] : null;
        $statusMessage = isset($_POST['status_message']) ? $_POST['status_message'] : 'PayHere notification received';
        $md5sig = isset($_POST['md5sig']) ? $_POST['md5sig'] : '';

        if ($orderId === '') {
            http_response_code(400);
            echo 'Missing order ID';
            exit;
        }

        require_once BASE_PATH . '/app/models/Donation.php';

        $donation = Donation::getByTransactionId($orderId);

        if (!$donation) {
            http_response_code(404);
            echo 'Donation not found';
            exit;
        }

        // Optional signature verification for hosted environment
        // Replace with your real merchant secret when deploying publicly
        $merchantSecret = 'PASTE_YOUR_MERCHANT_SECRET_HERE';

        $localMd5sig = strtoupper(
            md5(
                $merchantId .
                $orderId .
                $payhereAmount .
                $payhereCurrency .
                $statusCode .
                strtoupper(md5($merchantSecret))
            )
        );

        $signatureValid = !empty($merchantSecret) && $md5sig !== '' && $localMd5sig === strtoupper($md5sig);

        if ($statusCode == '2') {
            $paymentStatus = 'completed';
        } elseif (in_array($statusCode, array('0', '1'), true)) {
            $paymentStatus = 'pending';
        } else {
            $paymentStatus = 'failed';
        }

        Donation::updateGatewayResponse($orderId, array(
            'payment_status' => $paymentStatus,
            'gateway_payment_id' => $paymentId,
            'gateway_status_code' => $statusCode,
            'gateway_status_message' => $signatureValid ? $statusMessage : ($statusMessage . ' (signature not verified / localhost mode)'),
            'gateway_method' => $method
        ));

        if ($paymentStatus === 'completed') {
            Donation::updateReturnStatus($orderId, 'notify_confirmed');
        }

        echo 'OK';
        exit;
    }

    public function myDonations()
    {
        $donorId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        if (!$donorId) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        require_once BASE_PATH . '/app/models/Donation.php';
        $donations = Donation::getDonationsByDonor($donorId);
        view('donation/history', array('donations' => $donations));
    }

    public function receipt($id = null)
    {
        if (!$id) {
            header('Location: ' . BASE_URL);
            exit;
        }
        require_once BASE_PATH . '/app/models/Donation.php';
        $donation = Donation::getDonationWithEventAndUniversity($id);
        if (!$donation) {
            echo "Receipt not found.";
            exit;
        }
        view('donation/receipt', array('donation' => $donation));
    }

    public function requestConfirmation($id = null)
    {
        if (!$id) {
            header('Location: ' . BASE_URL);
            exit;
        }
        require_once BASE_PATH . '/app/models/Donation.php';
        $donation = Donation::getDonationWithEventAndUniversity($id);
        view('donation/request-confirmation', array('donation' => $donation, 'eventId' => $id));
    }
}
