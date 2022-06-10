document.getElementById('registerForm').addEventListener('submit', event => {
  event.preventDefault();

  const firstName = document.getElementById('firstName').value;
  const lastName = document.getElementById('lastName').value;
  const username = document.getElementById('username').value;
  const email = document.getElementById('email').value;
  const facultyNumber = document.getElementById('fn').value;
  const password = document.getElementById('spassword').value;
  const rePassword = document.getElementById('repassword').value;
  const role = document.getElementById('role').value;

  // Validate
  // Check pass

  const formData = {
    firstName,
    lastName,
    username,
    email,
    facultyNumber,
    password,
    rePassword,
    role,
  };

  register(formData)
    .then(response => {
      console.log(response);
      if (response.success) {
        console.log(response);
        // location.replace('../create-invitation/create-invitation.html');
      } else {
        document.getElementById('user-message').innerText = response.message;
      }
    })
    .catch(err => console.log(err));
});

const register = async data => {
  console.log('in register');
  const response = await fetch('../../backend/endpoints/register.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  });
  console.log(response);
  console.log('after fetch');
  const result = await response.json();
  return result;
};
