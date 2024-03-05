const checkbox = document.getElementById("checkbox")
checkbox.addEventListener("change", () => {
    if (document.documentElement.getAttribute('data-bs-theme') == 'dark') {
        document.documentElement.setAttribute('data-bs-theme','light')
    }
    else {
        document.documentElement.setAttribute('data-bs-theme','dark')
    }
})
    if($('.open-projectCard')){
        $(".open-projectCard").click(function () {
    $('#projectName').val($(this).data('projectname'));
    $('#description').val($(this).data('description'));
    $('#projectCard').modal('show');
});
}

if($('#modalCardClose')){
    $('#modalCardClose').click(function() {
        $('#projectUpdateForm').submit();
    })
}

function confirmDelete(event, id) {
    event.preventDefault();
    if (confirm('Are you sure you want to delete this?')) {
        document.getElementById('projectDelete-' + id).submit();
    }
}
