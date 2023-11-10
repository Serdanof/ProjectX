document.addEventListener('turbo:load', loadClientInvoicePage);

function loadClientInvoicePage () {
    if (!$('#invoices-tab').length) {
        return false;
    }
    let tabParameter = $('#activeTabOfClient').val();
    $('.nav-item button[data-bs-target="#' + tabParameter + '"]').click();
}
