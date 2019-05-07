function togglelink(id) {
  var boxstate = document.getElementById("checkbox_" + id).checked;
  var el = document.getElementById("edit_" + id);
  var dl = document.getElementById("delete_" + id);
  if (boxstate) {
     el.style = "display: none;";
     dl.style = "display: block;";
  } else {
     dl.style = "display: none;";
     el.style = "display: block;";
  }  
}
