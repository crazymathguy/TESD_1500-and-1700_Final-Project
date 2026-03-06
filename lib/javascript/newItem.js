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
	form.action = 'lib/newItem.php';
	form.method = 'post';
	form.target = '_blank';
	form.innerHTML = htmlCode;
	document.body.append(form);

	const overlay = document.createElement('div');
	overlay.id = 'formOverlay';
	overlay.className = 'overlay';
	document.body.append(overlay);

	form.addEventListener('submit', (event) => {
		const formData = new FormData(event.target);
		const data = Object.fromEntries(formData.entries());
		form.submit();

		const newRow = document.createElement('tr');
		var htmlCode = '';
		Object.values(data).forEach(element => {
			console.log(`The value is ${element}`);
			htmlCode += '<td>' + element + '</td>';
		});
		newRow.innerHTML = htmlCode;

		document.getElementById('collectionTable').append(newRow);
		ClosePopup();
	});

	overlay.addEventListener('mouseup', function() {
		overlay.addEventListener('click', ClosePopup());
	}, {once: true});
}

function ClosePopup() {
	document.body.removeChild(document.getElementById('popupForm'));
	document.body.removeChild(document.getElementById('formOverlay'));
}