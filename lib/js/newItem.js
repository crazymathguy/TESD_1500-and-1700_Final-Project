"use strict";

/*
	Library Management New Item on Main Access Page
	Author: Sean Briggs
	Date Created: 2026-03-05

	Filename: newItem.js
*/

function AddNew() {
	var htmlCode = '<br /><label for="title">ISBN:</label>'
	+ '<input type="text" name="isbn" id="isbn" size="13" maxlength="13" required />'
	+ '<br /><label for="title">Author:</label>'
	+ '<input type="text" name="author" id="author" size="20" maxlength="50" required />'
	+ '<br /><label for="title">Title:</label>'
	+ '<input type="text" name="title" id="title" size="20" maxlength="100" required />'
	+ '<br /><label for="title">Shelf Location:</label>'
	+ '<input type="text" name="shelf" id="shelf" size="20" maxlegnth="50" required />'
	+ '<br /><label for="title">Item Location:</label>'
	+ '<input type="number" name="item" id="item" size="3" min="0" max="255" required />'
	+ '<br /><input type="submit" value="Add Item" />';

	const form = document.createElement('form');
	form.action = 'lib/newItem.php';
	form.method = 'post';
	form.target = '_blank';
	form.innerHTML = htmlCode;

	document.body.append(form);

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
		document.body.removeChild(form);
	});
}