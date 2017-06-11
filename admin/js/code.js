function selectall(source) {
  checkbox = document.getElementsByClassName("chk");
  n=checkbox.length;
  for(var i=0;i<n;i++) {
    checkbox[i].checked = source.checked;
  }
}