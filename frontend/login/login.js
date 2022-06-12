if (localStorage.getItem('user')) {
  location.replace('../create_invitation/create_invitation.html');
}

document.getElementById('login').addEventListener('submit', event => {
  event.preventDefault();

  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;

  const loginData = {
    username,
    password,
  };

  login(loginData).then(async response => {
    if (response.success) {
      // maybe return session id and save session id
      localStorage.setItem('user', response.data);
      location.replace('../create_invitation/create_invitation.html');
    } else {
      document.getElementById('error').classList.add('error');
      document.getElementById('error').innerText = response['error'];
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
