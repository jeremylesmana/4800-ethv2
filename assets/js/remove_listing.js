function openForm() {
    document.getElementById("myForm").style.display = "block";
}

function closeForm() {
    document.getElementById("myForm").style.display = "none";
}

function validate_text_match(txt) {
    var bt = document.getElementById('confirm');
    var nft_name = document.getElementById('nft_name');
    if (txt.value == nft_name.textContent) {
        bt.disabled = false;
    }
    else {
        bt.disabled = true;
    }
}

function go(id) {
    window.location.href = "remove_listing.php?listingID=" + id;
}