document.querySelector('#login').addEventListener('click', function ()
{
  document.getElementById('hide').style.display = "none";
  document.getElementById('show').style.display = "inline";
});
document.querySelector('#show').addEventListener('click', function ()
{
  document.getElementById('form-title').style.opacity = "1";
});
