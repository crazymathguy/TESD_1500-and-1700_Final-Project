"use strict";

/*
	Library Management New Item on Main Access Page
	Author: Sean Briggs
	Date Created: 2026-03-05

	Filename: newItem.js
*/

function AddNew() {
	var htmlCode = '<label for="title">ISBN:</label>'
	+ '<input type="text" name="isbn" id="isbn" maxlength="13" required />'
	+ '<label for="title">Author:</label>'
	+ '<input type="text" name="author" id="author" maxlength="50" required />'
	+ '<label for="title">Title:</label>'
	+ '<input type="text" name="title" id="title" maxlength="100" required />'
	+ '<label for="title">Shelf Location:</label>'
	+ '<input type="text" name="shelf" id="shelf" maxlength="50" required />'
	+ '<label for="title">Item Location:</label>'
	+ '<input type="number" name="item" id="item" min="0" max="255" required />'
	+ '<input type="submit" id="add" value="Add Item" />';

	const form = document.createElement('form');
	form.id = 'popupForm';
	form.className = 'popup';
	form.action = 'lib/newItem.php';
	form.method = 'post';
	form.target = '_blank';
	form.innerHTML = htmlCode;

	const overlay = document.createElement('div');
	overlay.id = 'formOverlay';
	overlay.className = 'overlay';

	document.body.append(form, overlay);
	var buttons = document.querySelectorAll('button');
	buttons.forEach (button => {
		button.disabled = true;
	});

	form.addEventListener('submit', (event) => {
		const formData = new FormData(event.target);
		const data = Object.fromEntries(formData.entries());
		form.submit();

		const newRow = document.createElement('tr');
		var htmlCode = '';
		Object.values(data).forEach(element => {
			htmlCode += '<td>' + element + '</td>';
		});
		//htmlCode += '<td><button class="trash" onclick="Delete(\'row'.$id.'\')" >&#x1F5D1;</button></td>';
		newRow.innerHTML = htmlCode;

		document.getElementById('collectionTable').append(newRow);
		ClosePopup(form, overlay);
	});

	overlay.addEventListener('mouseup', function() {
		overlay.addEventListener('click', ClosePopup(form, overlay));
	}, {once: true});
}

function ClosePopup(popup, overlay) {
	document.body.removeChild(popup);
	document.body.removeChild(overlay);
	var buttons = document.querySelectorAll('button');
	buttons.forEach (button => {
		button.disabled = false;
	});
}

function Delete(id) {
	const popup = document.createElement('div');
	popup.id = 'popupNotice';
	popup.className = 'popup';
	popup.innerHTML = '<p>Are you sure you want to delete this item?</p>';

	const overlay = document.createElement('div');
	overlay.id = 'formOverlay2';
	overlay.className = 'overlay';

	document.body.append(popup, overlay);
	overlay.addEventListener('mouseup', function() {
		overlay.addEventListener('click', ClosePopup(popup, overlay));
	}, {once: true});

	const okButton = document.createElement('button');
	okButton.id = 'ok';
	okButton.onclick = Ok(id);
	okButton.innerText = 'OK';

	const cancelButton = document.createElement('button');
	cancelButton.id = 'cancel';
	cancelButton.onclick = ClosePopup(popup, overlay);
	cancelButton.innerText = 'Cancel';

	popup.append(okButton, cancelButton);

	var buttons = document.querySelectorAll('button');
	buttons.forEach (button => {
		button.disabled = true;
	});
}

function Ok(id) {

}