const userData = localStorage.getItem("user");
const user = JSON.parse(userData);

if (user.role !== "teacher") {
  location.replace("../invitations/invitations.html");
}

async function getLazyUsers(term = "") {
  const response = await fetch("../../backend/endpoints/statistics.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ term }),
  });
  const result = await response.json();
  return result;
}
function addUsers(users) {
  [...document.getElementsByClassName("user-element")].forEach((element) => {
    if (!element.classList.contains("header")) {
      element.remove();
    }
  });

  users.forEach((user) => {
    const usersElement = document.createElement("div");
    usersElement.classList.add("user-element");

    Object.values(user).forEach(
      (prop) => (usersElement.innerHTML += `<span>${prop}</span>`)
    );
    document.getElementById("main-element").appendChild(usersElement);
  });
}

getLazyUsers().then((response) => {
  if (response["success"] == true) {
    const users = JSON.parse(response["data"]);
    const count = response["count"];
    console.log(response);
    const element = document.getElementById("counts");
    if (element.innerHTML === "") {
      element.innerHTML =
        users.length + " от " + count["count(id)"] + " не са качили покана";
    }

    addUsers(users);
  }
});

document.getElementById("search-bar").addEventListener("change", () => {
  const term = document.getElementById("search-bar").value;

  getLazyUsers(term).then((response) => {
    if (response.success) {
      const invitations = JSON.parse(response.data);
      addUsers(invitations);
    }
  });
});
