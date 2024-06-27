function confirmationPopUp(textNr, elementId) {
    if (textNr == 1) {
        text = "Do you really want to delete this account?"
    } else if (textNr == 2) {
        text = "Are you sure, you want to update the E-Mail?"
    } else if (textNr == 3) {
        text = "Are you sure, you want to change the password?"
    } else {
        return
    }
    var userConfirmed = confirm(text);
            if (userConfirmed) {
                document.getElementById(elementId).submit();
            }
}