let localStream;
let remoteStream;
let peerConnection;
let mediaRecorder;
let recordedChunks = [];

// Dummy STUN server (for real use, configure TURN too)
const servers = { iceServers: [{ urls: "stun:stun.l.google.com:19302" }] };

const startCallBtn = document.getElementById("startCall");
const endCallBtn = document.getElementById("endCall");
const statusEl = document.getElementById("status");
const localVideo = document.getElementById("localVideo");
const remoteVideo = document.getElementById("remoteVideo");

startCallBtn.onclick = async () => {
    try {
        localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        localVideo.srcObject = localStream;

        peerConnection = new RTCPeerConnection(servers);
        remoteStream = new MediaStream();
        remoteVideo.srcObject = remoteStream;

        localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));
        peerConnection.ontrack = event => {
            event.streams[0].getTracks().forEach(track => remoteStream.addTrack(track));
        };

        // Setup recording
        mediaRecorder = new MediaRecorder(localStream);
        mediaRecorder.ondataavailable = e => {
            if (e.data.size > 0) recordedChunks.push(e.data);
        };
        mediaRecorder.onstop = saveRecording;
        mediaRecorder.start();

        statusEl.innerText = "Status: Call Started";
        startCallBtn.disabled = true;
        endCallBtn.disabled = false;

    } catch (err) {
        console.error("Error starting call:", err);
        alert("Failed to access camera/mic.");
    }
};

endCallBtn.onclick = () => {
    peerConnection.close();
    mediaRecorder.stop();
    statusEl.innerText = "Status: Call Ended";
    startCallBtn.disabled = false;
    endCallBtn.disabled = true;
};

function saveRecording() {
    const blob = new Blob(recordedChunks, { type: "video/webm" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "call_recording.webm";
    a.click();
}
