// SET BASE URL
var base_url = "http://localhost:8000";
var itemsPerPage = 10;

// FETCH BOOKS FROM API/URL
const getBooks = async (url) => {
    try {
        const response = await axios.get(url);
        // Display Books
        displayBooks(response.data.data.data);
    } catch (error) {
        throw new Error(error);
    }
};

// INITIALIZE THE DEFAULT LIST OF BOOKS
getBooks(`${base_url}/api/v1/books?items=${itemsPerPage}`);

// DISPLAY THE LIST OF BOOKS
const displayBooks = (books) => {
    let data = "";
    books.map((book) => {
        const {
            id,
            name,
            isbn,
            authors,
            publisher,
            country,
            number_of_pages,
            release_date,
        } = book;

        data += `
            <li class="item">
            <h4>${name}</h4>
            <p><i>${authors}</i></p>
            <small>ISBN: ${isbn}</small>
            <hr />
            <p>${publisher}, ${country}</p>
            <small>${number_of_pages} Pages | ${release_date}</small>
          <div class="btn-group">
            <button class="green" onclick="editBook(${id})">Edit</button>
            <button class="red" type="submit" onclick="deleteBook(${id})">Delete</button>
          </div>
        </li>`;
    });
    document.getElementById("myBookList").innerHTML = data;
};

// DELETE A BOOK
const deleteBook = (id) => {
    axios
        .delete(`${base_url}/api/v1/books/${id}`)
        .then(function (response) {
            getBooks(`${base_url}/api/v1/books?items=${itemsPerPage}`);
            alert(response.data.message);
        })
        .catch(function (error) {
            throw new Error(error);
        });
};

// POP UP FORM TO EDIT BOOK
const editBook = (id) => {
    // Make a request for the book with the given ID
    axios
        .get(`${base_url}/api/v1/books/${id}`)
        .then(function (response) {
            let book = response.data.data[0];
            const {
                id,
                name,
                isbn,
                authors,
                publisher,
                country,
                number_of_pages,
                release_date,
            } = book;

            // SHOW EDIT FORM
            let form = `
                <div class="form-popup" id="myForm">
                    <form class="form-container" id="editForm">
                    <h1>Edit Book</h1>
                    
                    <b>Name:</b>
                    <input
                        type="text"
                        placeholder="${name}"
                        value="${name}"
                        id="name"
                        required
                    /><br />
                    <b>ISBN:</b>
                    <input
                        type="text"
                        placeholder="${isbn}"
                        value="${isbn}"
                        id="isbn"
                        required
                    /><br />
                    <b>Authors:</b>
                    <input
                        type="text"
                        placeholder="${authors}"
                        value="${authors}"
                        id="authors"
                        required
                    /><br />
                    <b>Pages:</b>
                    <input
                        type="text"
                        placeholder="${number_of_pages}"
                        value="${number_of_pages}"
                        id="number_of_pages"
                        required
                    /><br />
                    <b>Publisher:</b>
                    <input
                        type="text"
                        placeholder="${publisher}"
                        value="${publisher}"
                        id="publisher"
                        required
                    /><br />
                    <b>Country:</b>
                    <input
                        type="text"
                        placeholder="${country}"
                        value="${country}"
                        id="country"
                        required
                    /><br />
                    <b>Date:</b>
                    <input
                        type="text"
                        placeholder="${release_date}"
                        value="${release_date}"
                        id="release_date"
                        required
                    />

                    <button type="submit" class="btn" onclick="submitForm(${id})">Update</button>
                    <button type="submit" class="btn cancel" onclick="off()">
                        Cancel
                    </button>
                    </form>
                </div>`;
            // SHOW FORM
            document.getElementById("overlay").innerHTML = form;
        })
        .catch(function (error) {
            throw new Error(error);
        })
        .then(function () {
            document.getElementById("overlay").style.display = "block";
        });
};

// REMOVE POP UP EDIT FORM
const off = () => {
    document.getElementById("overlay").style.display = "none";
};

// SUBMIT UPDATED FORM
const submitForm = (id) => {
    let form = {
        name: document.getElementById("name").value,
        isbn: document.getElementById("isbn").value,
        authors: document.getElementById("authors").value,
        number_of_pages: document.getElementById("number_of_pages").value,
        publisher: document.getElementById("publisher").value,
        country: document.getElementById("country").value,
        release_date: document.getElementById("release_date").value,
    };

    // Send the update request
    axios
        .put(`${base_url}/api/v1/books/${id}`, form)
        .then(function (response) {
            getBooks(`${base_url}/api/v1/books`);
        })
        .catch(function (error) {
            throw new Error(error);
        });
};
