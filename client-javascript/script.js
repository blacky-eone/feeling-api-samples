// set API url and access token
const URL = '<url>';
const TOKEN = '<access_token>';


document.addEventListener('DOMContentLoaded', () => {
  const fileInput = document.getElementById('file_input');
  fileInput.addEventListener('change', postAudio)
})

function postAudio(event) {
  let formData = new FormData();
  formData.append('file', event.target.files[0]);

  const headers = {
      'Authorization': `Bearer ${TOKEN}`,
  };

  const opt = {
      method: 'POST',
      body: formData,
      headers: headers
  };

  fetch(
      URL, opt
  ).then((res) => {
      return res.json()
  }).then((json) => {
      console.log(json);
  }).catch((err) => {
      console.log(err);
  });
}
