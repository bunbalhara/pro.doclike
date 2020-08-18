'use strict';

function getProfilePicUrl() {
    return userPicElement.value;
}
function getUserName() {
    return userNameElement.value;
}
function saveImageMessage(file) {
    firebase.firestore().collection(nodeIdElement.value).add({
        _id:Date.now(),
        name: getUserName(),
        imageUrl: LOADING_IMAGE_URL,
        profilePicUrl: getProfilePicUrl(),
        fileName: file.name,
        user: {_id: document.getElementById('login-id').value},
        createdAt: firebase.firestore.FieldValue.serverTimestamp()
    }).then(function(messageRef) {
        var filePath = firebase.auth().currentUser.uid + '/' + messageRef.id + '/' + file.name;
        return firebase.storage().ref(filePath).put(file).then(function(fileSnapshot) {
        return fileSnapshot.ref.getDownloadURL().then((url) => {
            if (!file.type.match('image.*')) {
                var messageText = '';
                messageText += '<a target="_blank" href="'+ url + '">'+  file.name + ' <i class="fas fa-download"></i> </a>';
                return messageRef.update({
                    imageUrl: url,
                    text: messageText,
                    fileName: file.name,
                    storageUri: fileSnapshot.metadata.fullPath
                });
            } else {
                var messageText = '';
                    messageText += '<img class="chat-img" src="'+ url + '"><br>';
                    messageText += '<a target="_blank" href="'+ url + '">'+  file.name + ' <i class="fas fa-download"></i> </a>';
                    return messageRef.update({
                    imageUrl: url,
                    text: messageText,
                    fileName: file.name,
                    storageUri: fileSnapshot.metadata.fullPath
                });
            }
        });
    });
}).catch(function(error) {
    console.error('There was an error uploading a file to Cloud Storage:', error);
});
}
function onMediaFileSelected(event) {
    event.preventDefault();
    var file = event.target.files[0];
    imageFormElement.reset();
    saveImageMessage(file);
}
function resetMaterialTextfield(element) {
    element.value = '';
}
function saveMessage(messageText) {
    return firebase.firestore().collection(nodeIdElement.value).add({
        _id: Date.now(),
        text: messageText,
        user: {_id: document.getElementById('login-id').value},
        createdAt: firebase.firestore.FieldValue.serverTimestamp()
    }).catch(function(error) {
        console.error('Error writing new message to Firebase Database', error);
    });
}
function checkSignedInWithMessage() {
    return true;
}
function onMessageFormSubmit(e) {
    e.preventDefault();
    if (messageInputElement.value && checkSignedInWithMessage()) {
        saveMessage(messageInputElement.value).then(function() {
        resetMaterialTextfield(messageInputElement);
    });
    }

}
function displayMessage(id, timestamp, text, picUrl, messageArray) {
    timestamp = timestamp ? timestamp.toMillis() : Date.now();
    if(timestamp){
        var a = moment(); 
        var b = moment(timestamp).toDate(); 
        var diff = a.diff(b, 'days');
        var dateText = '';
        if(diff == 0){
            dateText = 'Today';
        }
        else if(diff == 1){
            dateText = 'Yesterday';
        }
        else{
            dateText = moment(timestamp).toDate();
        }
    }
    if (dataId != id) {
        if (picUrl) {
            var image = document.createElement('img');
            image.addEventListener('load', function() {
                messageListElement.scrollTop = messageListElement.scrollHeight;
            });
            image.src = picUrl + '&' + new Date().getTime();
            element = '<div class="media-body"><div class="msg-box"><div><div class="chat-msg-attachments"><div class="chat-attachment"><img src="' +
                    image.src + '"></div></div><ul class="chat-msg-info"><li><div class="chat-time"><span>' + dateText + '</span></div></li></ul></div></div></div></div></li>';
            if(document.getElementById('login-id').value == messageArray.user._id) {
                element = '<li class="media sent" id="' + id + '">' + element;
            } else {
                element = '<li class="media received" id="' + id + '">' + element;
            }
        } else {
            if(document.getElementById('login-id').value == messageArray.user._id) {
            element = '<li class="media sent" id="' + id + '"><div class="media-body"><div class="msg-box"><div><p>' + messageArray.text + '</p>' +
                '<ul class="chat-msg-info"><li><div class="chat-time"><span>' + dateText + '</span></div></li></ul>' +
                '</div></div></div></li>';
            } else {
                element = '<li class="media received"><div class="avatar"><img src="' + userPicElement.value +'" alt="User Image" class="avatar-img rounded-circle"></div>' +
                    '<div class="media-body"><div class="msg-box"><div><p>' + messageArray.text + '</p><ul class="chat-msg-info">' +
                    '<li><div class="chat-time"><span>' + dateText + '</span></div></li></ul></div></div></div></li>';
            }
        }
        if (lastTimestamp < timestamp) {
            html += element;
        } else {
            html = element + html;
        }
        lastTimestamp = timestamp;
    }
    dataId = id;
}
function deleteMessage(id) {
    var div = document.getElementById(id);
    // If an element for that message exists we delete it.
    if (div) {
        div.parentNode.removeChild(div);
    }
}
function initFirebaseAuth() {
    firebase.auth().signInAnonymously().catch(function(error) {
        console.log(error);
    });
}
function loadMessages() {
    var query = firebase.firestore().collection(nodeIdElement.value).orderBy('createdAt', 'desc').limit(50);
    query.onSnapshot(function(snapshot) {
        snapshot.docChanges().forEach(function(change) {
            if (change.type === 'removed') {
                deleteMessage(change.doc.id);
            } else {
                var message = change.doc.data();
                var epoch = new Date(message.createdAt);
                var date = epoch.toUTCString();
                displayMessage(change.doc.id, message.createdAt, message.text, message.imageUrl, message);
            }
        });
        messageListElement.innerHTML = html;
    });
}
var LOADING_IMAGE_URL = 'https://www.google.com/images/spin-32.gif?a';
var html = ''; var element = ''; var lastTimestamp = 0; var dataId = 0;
var userPicElement = document.getElementById('user-pic');
var messageListElement = document.getElementById('message_card');
var nodeIdElement = document.getElementById('node-id');
var messageFormElement = document.getElementById('message_form');
var messageInputElement = document.getElementById('message');
var imageFormElement = document.getElementById('image_form');
var mediaCaptureElement = document.getElementById('mediaCapture');
var imageButtonElement = document.getElementById('submitImage');
var userNameElement = document.getElementById('user-name');

messageFormElement.addEventListener('submit', onMessageFormSubmit);

imageButtonElement.addEventListener('click', function(e) {
    e.preventDefault();
    mediaCaptureElement.click();
});
mediaCaptureElement.addEventListener('change', onMediaFileSelected);

initFirebaseAuth();
var firestore = firebase.firestore();
firebase.performance();
loadMessages();