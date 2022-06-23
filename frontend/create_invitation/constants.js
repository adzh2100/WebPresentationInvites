const userData = localStorage.getItem("user");
const user = JSON.parse(userData);

export const text = `Здравейте! Каня ви на презентацията на ${user.first_name} ${user.last_name} с ФН: ${user.academical_number}`;
