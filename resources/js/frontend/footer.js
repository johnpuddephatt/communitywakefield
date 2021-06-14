const footerElement = document.querySelector('.primary-footer');

if (footerElement && 'IntersectionObserver' in window) {
  document.body.classList.remove('intersectionless-footer');
  createObserver();
}

function createObserver() {
  var observer = new IntersectionObserver(
    handleIntersect,
    {
      root: null,
      rootMargin: '0px',
      threshold: [0.5,1],
    }
  );
  observer.observe(footerElement);
}

function handleIntersect(entry) {
  if(entry[0].intersectionRatio > 0.5) {
    document.body.classList.add('has-visible-footer');
  }
  else {
    document.body.classList.remove('has-visible-footer');
  }
}
