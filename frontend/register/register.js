function register(event) {
  event.preventDefault();

  const fullName = docuement.getElementById('fullName').value;
  const username = document.getElementById('username').value;
  const facultyNumber = document.getElementById('fn').value;
  const password = document.getElementById('spassword').value;
  const rePassword = document.getElementById('repassword').value;
  const role = document.getElementById('role').value;

  // Validate
  // Check pass

  const formData = {
    fullName,
    username,
    facultyNumber,
    password,
    role,
  };

  fetch('../../backend/endpoints/login.php', {
    method: 'POST',
    body: JSON.stringify(formData),
  })
    .then(response => response.json())
    .then(response => {
      if (response.success) {
        location.replace('../home/home.html');
      } else {
        document.getElementById('user-message').innerText = response.message;
      }
    });
}
