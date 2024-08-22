$('#editModal').on('show.bs.modal', function (e) {
  let addressId = $(e.relatedTarget).data('id')
  let addressRow = getAddressRow(addressId)

  $(e.currentTarget)
    .find('#editId')
    .text(
      addressRow.firstname +
        ' ' +
        addressRow.lastname +
        ' (ID: ' +
        addressRow.id +
        ')'
    )

  $.each(addressRow, function (key, value) {
    $(e.currentTarget)
      .find('#' + key)
      .val(value)
  })
})

$('#deleteModal').on('show.bs.modal', function (e) {
  let addressId = $(e.relatedTarget).data('id')
  let addressRow = getAddressRow(addressId)

  $(e.currentTarget)
    .find('#deleteId')
    .text(
      addressRow.firstname +
        ' ' +
        addressRow.lastname +
        ' (ID: ' +
        addressRow.id +
        ')'
    )

  $.each(addressRow, function (key, value) {
    $(e.currentTarget)
      .find('#' + key)
      .val(value)
  })
})

function getAddressRow (addressId) {
  var row = {}

  $.ajax({
    url: 'api/address-row.php',
    type: 'post',
    data: { id: addressId },
    async: false
  }).done(function (response) {
    if (!isJsonString(response)) {
      alert(response)
    } else {
      response = JSON.parse(response)
      row = response
    }
  })

  return row
}

function isJsonString (str) {
  try {
    JSON.parse(str)
  } catch (e) {
    return false
  }
  return true
}
