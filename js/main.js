function hide_msg () {
    const element = document.getElementById("msg");
    element.remove();
}

function set_datetime () {
    let field = document.getElementById("date");
    field.value = new Date().toISOString().slice(0, 10);
}


