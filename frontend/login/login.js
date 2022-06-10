document.getElementById('login').addEventListener('submit', event => {
  event.preventDefault();

  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;

  const loginData = {
    username,
    password,
  };

  login(loginData).then(response => {
    if (response.success) {
      location.replace('../create_invitation/create_invitation.html');
    } else {
      // We should create such element and handle it properly
      document.getElementById('user-message').innerText = response.message;
    }
  });
});

async function login(data) {
  const response = await fetch('../../backend/endpoints/login.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  });

  const result = await response.json();
  return result;
}
