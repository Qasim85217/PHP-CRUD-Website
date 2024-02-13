function display_prompt() {
    document.querySelector("#main-prompt").style = "display:none;"
}
post_view = 0
function rules_post() {
    document.querySelector("#warned_title").textContent = "";
    document.querySelector("#warned_desc").textContent = "";
    document.querySelector("#instruction_para").style.display = "block"
    post_view += 1
    if (post_view > 4) {
        document.querySelector("#instruction_para").style.display = "none"

    }
}


function post_note() {
    var dtitle = document.querySelector("#noteinputtitle").value
    var ddesc = document.querySelector("#noteinputdesc").value
    if (dtitle == "") {
        document.querySelector("#warned_title").textContent = "Title must not be blank";
        return false;
    }
    if (ddesc == "") {
        document.querySelector("#warned_desc").textContent = "Describtion must not be blank";
        return false;
    }
}



// Selecting the search input and table rows
const search = document.querySelector("#searchbox");
const table_rows = document.querySelectorAll('tbody tr');

// Event listener for search input
search.addEventListener('input', searchTable);


// Variables for pagination
let firstline = 0;
let lastline = 9; // Assuming initially 10 rows are displayed
const pageSize = 10; // Number of rows to display per page

// Function to update displayed rows based on pagination state
function updateDisplayedRows(startIdx, endIdx) {
    table_rows.forEach((row, index) => {
        row.style.display = (index >= startIdx && index < endIdx) ? 'table-row' : 'none';
    });
    firstline = startIdx;
    lastline = endIdx - 1;
}

// Generate pagination buttons
const divrows = Math.ceil(table_rows.length / pageSize);
let sortno = document.querySelector('.sortno');
for (let i = 1; i <= divrows; i++) {
    sortno.innerHTML += `<button class="sort-no-btn" value="${i}">${i}</button>`;
}

// Event listener for pagination buttons
const sort_no_Buttons = document.querySelectorAll('.sort-no-btn');
sort_no_Buttons.forEach(button => {
    button.addEventListener('click', function () {
        const pageNum = parseInt(this.value);
        const startIdx = (pageNum - 1) * pageSize;
        const endIdx = Math.min(pageNum * pageSize, table_rows.length);
        updateDisplayedRows(startIdx, endIdx);
    });
});

// Event listener for pagination arrows
const sort_arrow_Buttons = document.querySelectorAll('.sort-arrow-btn');
sort_arrow_Buttons.forEach(button => {
    button.addEventListener('click', function () {
        if (this.textContent === '≪') {
            sort_arrow_Button1();
        } else if (this.textContent === '≫') {
            sort_arrow_Button2();
        }
    });
});

// Initially update displayed rows
updateDisplayedRows(firstline, lastline + 1);

// Function to handle search functionality
function searchTable() {
    const searchText = search.value.trim().toLowerCase(); // Trim whitespace and convert to lowercase
    if (searchText === '') { // If search box is empty, reset table to its original state
        updateDisplayedRows(firstline, lastline + 1);
    } else {
        table_rows.forEach((row) => {
            const rowData = row.textContent.toLowerCase();
            if (rowData.includes(searchText)) {
                row.style.display = 'table-row'; // Show the row if it contains the search text
            } else {
                row.style.display = 'none'; // Hide the row if it does not contain the search text
            }
        });
    }
}

function openeditmodal() {
    document.querySelector("#modal-back").style.display = "block";
    document.querySelector("#edit-modal").style.display = "block";
}

function closeeditmodal() {
    document.querySelector("#modal-back").style.display = "none";
    document.querySelector("#edit-modal").style.display = "none";
}

function opendeletemodal() {
    document.querySelector("#modal-back").style.display = "block";
    document.querySelector("#delete-modal").style.display = "block";
}

function closedeletemodal() {
    document.querySelector("#modal-back").style.display = "none";
    document.querySelector("#delete-modal").style.display = "none";
}
var a = 1
function sort_arrow_Button1() {
    a -= 1
    if (a < 1) {
        a = 1
    }

    const startIdx = Math.max(firstline - pageSize, 0);
    const endIdx = Math.min(startIdx + pageSize, table_rows.length);
    updateDisplayedRows(startIdx, endIdx);

}

function sort_arrow_Button2() {
    a += 1
    const startIdx = lastline + 1;
    const endIdx = Math.min(startIdx + pageSize, table_rows.length);
    if (a <= sort_no_Buttons.length) {
        updateDisplayedRows(startIdx, endIdx);
    }

    if (a > sort_no_Buttons.length) {
        a = sort_no_Buttons.length
    }

}
