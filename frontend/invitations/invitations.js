const userData = localStorage.getItem('user');
const user = JSON.parse(userData);
const main = document.getElementById('main-element');

if (user.role === 'guest') {
  location.replace('../login/login.html');
}

getInvitations().then(response => {
  if (response.success) {
    const invitations = JSON.parse(response.data);
    addInvitationsToPage(invitations);
  }
});

function addInvitationsToPage(invitations) {
  const headerElement = document.getElementsByClassName('header')[0];
  headerElement.innerHTML = '';
  [...document.getElementsByClassName('invitation-element')].forEach(
    element => {
      if (!element.classList.contains('header')) {
        element.remove();
      }
    }
  );
  document.getElementById('invitations')?.remove();
  let headers;

  if (user.role === 'student') {
    headerElement.classList.add('student');
    headers = ['Тема', 'Дата', 'Час', 'Описание', 'Име', 'Фамилия', 'ФН'];
  } else {
    headerElement.classList.add('teacher');
    headers = [
      'Тема',
      'Дата',
      'Час',
      'Описание',
      'Име',
      'Фамилия',
      'ФН',
      'Автоматично генерирана',
    ];
  }

  headers.forEach(
    header => (headerElement.innerHTML += `<span>${header}</span>`)
  );

  invitations.forEach(invitation => {
    const invitationElement = document.createElement('div');
    invitationElement.id = 'invitations';
    let autoGenerated = invitation['auto_generated'];
    delete invitation['auto_generated'];
    Object.values(invitation).forEach(
      prop => (invitationElement.innerHTML += `<span>${prop}</span>`)
    );

    invitationElement.classList.add('invitation-element');

    if (user.role === 'student') {
      invitationElement.classList.add('student');
    } else {
      invitationElement.classList.add('teacher');
      console.log(autoGenerated);
      invitationElement.innerHTML +=
        autoGenerated == 1
          ? '<span class="autogenerated">Да</span>'
          : '<span class="non-autogenerated">Не</span>';
    }
    main.appendChild(invitationElement);
  });
}

async function getInvitations(term = '') {
  const data = {
    role: user.role,
    term,
  };

  const response = await fetch('../../backend/endpoints/get-invitations.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  });

  const result = await response.json();
  return result;
}

document.getElementById('search-bar').addEventListener('change', () => {
  const term = document.getElementById('search-bar').value;

  getInvitations(term).then(response => {
    if (response.success) {
      const invitations = JSON.parse(response.data);
      addInvitationsToPage(invitations);
    }
  });
});
