<!DOCTYPE html>
<html>
<head>
    <title>Crisis Hotline Call</title>
    <link rel="stylesheet" href="/MindHeaven/public/css/call-responder/call-responder.css">
</head>
<body>
    <div class="call-container">
        <h1>📞 Crisis Hotline</h1>
        <p>Click below to connect with a responder.</p>

        <button id="startCall" class="btn">Call Now</button>
        <button id="endCall" class="btn danger" disabled>End Call</button>

        <!-- Video containers -->
        <div class="video-container">
            <video id="localVideo" autoplay muted></video>
            <video id="remoteVideo" autoplay></video>
        </div>

        <!-- Call status -->
        <p id="status">Status: Waiting...</p>
    </div>

    <script src="/js/webrtc.js"></script>
</body>
</html>
