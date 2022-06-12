document.getElementById('guest-btn').addEventListener('click', event => {
  localStorage.setItem(
    'user',
    JSON.stringify({
      role: 'guest',
    })
  );
});
