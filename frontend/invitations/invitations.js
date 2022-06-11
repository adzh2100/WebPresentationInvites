const main = document.getElementById('main-element');

getInvitations().then(response => {
  const invitations = JSON.parse(response.data);
  invitations.forEach(invitation => {
    const invitationElement = document.createElement('div');
    invitationElement.innerHTML = `
    <span>${invitation.date}</span>
    <span>${invitation.time}</span>
    <span>${invitation.presentation_theme}</span>
    <span>${invitation.academical_number}</span>
    <span>${invitation.first_name} ${invitation.last_name}</span>
    `;
    invitationElement.classList.add('invitation-element');
    main.appendChild(invitationElement);
  });
});

async function getInvitations() {
  const response = await fetch('../../backend/endpoints/get-invitations.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
  });

  const result = await response.json();
  return result;
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
