var filterHeadings = document.querySelectorAll('.filter-heading');

if(filterHeadings) {
  for(var i = 0; i < filterHeadings.length; i++) {
    filterHeadings[i].addEventListener('click',function(e){
      if(e.target.nextElementSibling.classList.contains('expanded')) {
        e.target.nextElementSibling.classList.remove('expanded')
      }
      else {
        var currentPanel = document.querySelector('.expanded');
        if(currentPanel) currentPanel.classList.remove('expanded');
        e.target.nextElementSibling.classList.add('expanded');
      }
    });
  }
}
