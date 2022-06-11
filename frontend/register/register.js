if (localStorage.getItem('user')) {
  location.replace('../create_invitation/create_invitation.html');
}

document.getElementById('registerForm').addEventListener('submit', event => {
  event.preventDefault();

  const firstName = document.getElementById('firstName').value;
  const lastName = document.getElementById('lastName').value;
  const username = document.getElementById('username').value;
  const email = document.getElementById('email').value;
  const facultyNumber = document.getElementById('fn').value;
  const password = document.getElementById('spassword').value;
  const rePassword = document.getElementById('repassword').value;
  const specification = document.getElementById('specification').value;
  const year = document.getElementById('year').value;


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
    specification,
    year,
  };

  register(formData)
    .then(response => {
      console.log(response);
      if (response.success) {
        // location.replace('../create_invitation/create_invitation.html');
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
