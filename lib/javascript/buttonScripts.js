"use strict";

/*
	Library Management New Item on Main Access Page
	Author: Sean Briggs
	Date Created: 2026-03-05

	Filename: buttonScripts.js
*/

function AddNew() {
	var htmlCode = `<label for="title">ISBN:</label>
		<input type="text" name="isbn" id="isbn" maxlength="13" required />
		<label for="title">Author:</label>
		<input type="text" name="author" id="author" maxlength="50" required />
		<label for="title">Title:</label>
		<input type="text" name="title" id="title" maxlength="100" required />
		<label for="title">Shelf Location:</label>
		<input type="text" name="shelf" id="shelf" maxlength="50" required />
		<label for="title">Item Location:</label>
		<input type="number" name="item" id="item" min="0" max="255" required />
		<input type="submit" id="add" value="Add Item" />`;
	
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

	form.addEventListener('submit', async (e) => {
		// Prevent the default navigation so we can submit via fetch and wait for the response
		e.preventDefault();
		const formData = new FormData(form);
		try {
			const resp = await fetch(form.action, { method: form.method.toUpperCase(), body: formData });
			if (!resp.ok) {
				console.error('Submission failed', resp.status, resp.statusText);
			}
			// Wait for the server to finish processing before refreshing data
			await fetchData();
		} catch (err) {
			console.error('Error submitting form', err);
		} finally {
			ClosePopup();
		}
	});

	overlay.addEventListener('mouseup', () => {
		overlay.addEventListener('click', ClosePopup());
	}, {once: true});
}

function Delete(id) {
	var htmlCode = `<p>Are you sure you want to delete this item?</p>
		<div class="break"></div>
		<input type="hidden" id="row" name="row" value="${id}" />
		<input type="submit" id="ok" value="Yes" />
		<input type="button" id="cancel" onclick="ClosePopup()" value="Cancel" />`;

	const form = document.createElement('form');
	form.id = 'popupNotice';
	form.className = 'popup';
	form.action = 'lib/removeItem.php';
	form.method = 'post';
	form.target = '_blank';
	form.innerHTML = htmlCode;

	const overlay = document.createElement('div');
	overlay.id = 'formOverlay2';
	overlay.className = 'overlay';

	document.body.append(form, overlay);
	var buttons = document.querySelectorAll('button');
	buttons.forEach (button => {
		button.disabled = true;
	});

	form.addEventListener('submit', async (e) => {
		e.preventDefault();
		const formData = new FormData(form);
		try {
			const resp = await fetch(form.action, { method: form.method.toUpperCase(), body: formData });
			if (!resp.ok) {
				console.error('Submission failed', resp.status, resp.statusText);
			}
			await fetchData();
		} catch (err) {
			console.error('Error submitting form', err);
		} finally {
			ClosePopup();
		}
	});

	overlay.addEventListener('mouseup', () => {
		overlay.addEventListener('click', ClosePopup());
	}, {once: true});
}

function ClosePopup() {
	document.body.removeChild(document.querySelector('.popup'));
	document.body.removeChild(document.querySelector('.overlay'));
	var buttons = document.querySelectorAll('button');
	buttons.forEach (button => {
		button.disabled = false;
	});
}