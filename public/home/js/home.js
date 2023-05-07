function openCity(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the link that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}


function paginate(teamID) {
  const dd_pageno = document.getElementById('page_no' + teamID);
  const dd_recsppage = document.getElementById('recsperpage' + teamID);
  // console.log('page_no' + teamID);
  const page_no = dd_pageno.value;
  const recsperpage = dd_recsppage.value;
  window.location.href = '/?page=' + teamID + ',' + page_no + ',' + recsperpage;
}

const displayedTeam = document.getElementById('teamID');
if (displayedTeam) {
  document.getElementById(displayedTeam.value).style.display = "block";
}