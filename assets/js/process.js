function searchBook(e) {
    var searchFormToken = document.getElementById("searchFormToken").value;
    var displayPage = document.getElementById("bookPage");
    var formData = 'searchValue=' + e.value + '&searchBoxForm=' + searchFormToken;

    // displayPage.innerText = '<div class="col-md-8"> <div class="step"><p class="text-center"> Searching... </p></div></div>';
    $.ajax({
        type: 'POST',
        url: '../process/index.php',
        data: formData,
        cache: false,
        success: function (data) {
            // console.log(data);

            if (data != '') {
                for (i = 0; i < data.length; i++) {
                    var booksResult = "<div class='col-md-4'>" +
                        "<div class='step'>" +
                        "<a href='../upload/books/" + data[i][' category'] + "/" + data[i]['book_cover'] + "'>" +
                        "<div class='wrap-icon icon-1 mt-4'>" +
                        "<img src='../upload/cover/" + data[i][' book_cover'] + " alt='" + data[i]['title'] + " Cover' height='300px'> " +
                        "</div>" +
                        "</a><h6 class='mt-4 post-text'>" +
                        "<span class='post-meta'><a href='#'>" + data[i]['author'] + " </a> </span> </h6>" +
                        "<a href='../upload/books/" + data[i][' category'] + "/" + data[i]['new_name'] + "'> <h5><b> " + data[i]['title'] + "</b></h5> </a>" +
                        "<span >" + data[i]['date_published'] + "<sup>" + data[i]['posted_by'] + "</sup> </span> <br> <sub> <b>" + data[i]['category'] + "</b></sub>" +
                        "<p class='text-danger'>" + data[i]['price'] + "</p> <p><a href='#'> 5 <i class='fa fa-eye'> </i></a> & nbsp; " +
                        "<p><a href='#'> 487 <i class='fa fa-book'> </i></a> & nbsp; <p><a href='#'> 5 <i class='fa fa-thumbs-up'> </i></a> & nbsp; " +
                        "<p><a href='#'> 5 <i class='fa fa-star'> </i></a> & nbsp; <p><a href='#'> 5 <i class='fa fa-download'> </i></a> & nbsp; " +
                        "</div></div>";
                    // displayPage.innerText += booksResult;
                    // console.log(booksResult);
                }
            } else {
                console.log("No book found with this keyword.");
            }
        },
        failure: function () {
            console.log("Could not complete search");
        }
    });
}

function loadBookCategory(e) {
    var displayPage = document.getElementById("bookPage");
    var searchFormToken = document.getElementById("searchFormToken").value;
    var formData = 'searchValue=' + e.value + '&categoryBoxForm=' + searchFormToken;

    $.ajax({
        type: 'POST',
        url: '../process/index.php',
        data: formData,
        cache: false,
        success: function (data) {
            console.log("Request completed");
        },
        failure: function () {
            console.log("Could not complete search");
        }
    });
}

function countViews(bookId, bookLink) {
    // Update number of views
    var searchFormToken = document.getElementById("searchFormToken").value;
    var userID = document.getElementById("userID").value;

    var formData = 'userID=' + userID + '&bookID=' + bookId + '&countViewsForm=' + searchFormToken;

    $.ajax({
        type: 'POST',
        url: '../process/index.php',
        data: formData,
        cache: false,
        success: function (data) {

            // Reload Page
            console.log('Success');
            // Open Book
            window.open(bookLink)
            // Log update
        },
        failure: function () {
            console.log("Network Error: Could not complete request");
        }
    });

}

function triggerDownload(bookId, bookLink) {
    var searchFormToken = document.getElementById("searchFormToken").value;
    var userID = document.getElementById("userID").value;

    var formData = 'userID=' + userID + '&bookID=' + bookId + '&downloadTriggerForm=' + searchFormToken;

    // Update download count
    $.ajax({
        type: 'POST',
        url: '../process/index.php',
        data: formData,
        cache: false,
        success: function (data) {
            // Open PDF File for user to download
            window.open(bookLink)
            // Download Book
            // bookLink.download = bookTitle + '.pdf';
            console.log("Book Downloaded");
        },
        failure: function () {
            console.log("Network Error: Could not complete request");
        }
    });
}