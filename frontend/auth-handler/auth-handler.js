if (!localStorage.getItem('user')) {
  location.href = '../login/login.html';
}

document.getElementById('logout-btn').addEventListener('click', event => {
  event.preventDefault();

  logout().then(response => {
    if (response.success) {
      localStorage.removeItem('user');
      location.replace('../login/login.html');
    }
  });
});

async function logout() {
  const response = await fetch('../../backend/endpoints/logout.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
  });

  const result = await response.json();
  return result;
}
