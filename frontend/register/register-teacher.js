if (localStorage.getItem('user')) {
  location.replace('../create_invitation/create_invitation.html');
}

document.getElementById('registerForm').addEventListener('submit', event => {
  event.preventDefault();

  const firstName = document.getElementById('firstName').value;
  const lastName = document.getElementById('lastName').value;
  const username = document.getElementById('username').value;
  const email = document.getElementById('email').value;
  const teacherNumber = document.getElementById('teacher-number').value;
  const password = document.getElementById('spassword').value;
  const rePassword = document.getElementById('repassword').value;

  const formData = {
    firstName,
    lastName,
    username,
    email,
    teacherNumber,
    password,
    rePassword,
    role: 'teacher',
  };

  register(formData)
    .then(response => {
      if (response.success) {
        localStorage.setItem('user', response.data);
        location.replace('../invitations/invitations.html');
      } else {
        document.getElementById('error').classList.add('error');
        document.getElementById('error').innerText = response['error'];
      }
    })
    .catch(err => console.log(err));
});

const register = async data => {
  const response = await fetch('../../backend/endpoints/register.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  });
  const result = await response.json();
  return result;
};
