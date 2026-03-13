"use strict";

/*
	Display table on main page (library.php)
	Author: Sean Briggs
	Date Created: 2026-03-13

	Filename: displayTable.js
*/

fetchData();

async function fetchData() {
	try {
		// Adding a timestamp ensures you bypass the browser cache
		const response = await fetch(`lib/getData.php?t=${Date.now()}`);
		if (!response.ok) throw new Error('Network response was not ok');
		const freshData = await response.json();

		const tableHead = document.querySelector('#collectionTable thead');
		tableHead.innerHTML = '';
		
		const headers = Object.keys(freshData[0]).slice(1);
		const headerRow = document.createElement('tr');
		headerRow.id = 'row0';

		headers.forEach(column => {
			headerRow.innerHTML += `<th>${column}</th>`;
		});
		headerRow.innerHTML += '<th>Remove</th>';
		tableHead.append(headerRow);

		const tableBody = document.querySelector('#collectionTable tbody');
		tableBody.innerHTML = '';

		freshData.forEach(row => {
			var id = Object.values(row)[0];
			const tr = document.createElement('tr');
			tr.id = `row${id}`;
			
			const allValues = Object.values(row).slice(1);
			allValues.forEach(item => {
				tr.innerHTML += `<td>${item}</td>`;
			});
			tr.innerHTML += `<td><button class="trash"
				onclick="Delete(${id})">&#x1F5D1;</button></td>`;
			
			tableBody.appendChild(tr);
		});
	} catch (error) {
		console.error("Error fetching data:", error);
	}
}