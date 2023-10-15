export function SpawnAlert()
{
    let theCdo = `
    <input type="checkbox" checked='false' id="alertCheckBox">
    <label for="alertCheckBox" id="AlertWindow">
    Error!
    <p>You must have no empty fields!</p>
    </div>`;
    $('body').append(theCdo);
}
export function Alert(textik)
{
    $('#AlertWindow p').text(textik);
    $('#alertCheckBox').prop('checked', false);
    setTimeout(() => {
        $('#alertCheckBox').prop('checked', true);
    }, 2500);
}