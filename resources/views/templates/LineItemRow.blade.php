<tr class="line-item">
    <td class='align-middle'>
        <input type='hidden' value='{{ $data->ID }}' name='Product[]'>
        [{{ $data->UniqueID }}] {{ $data->Description }}</td>
    <td class='align-middle'>
        <select class='form-control glcode-select' name='GLCode[]' required>
            <option>
            </option>
        </select>
    </td>
    <td class='text-center align-middle'>
        <div class='col-md-12 float-right'>
            <div class='row'>
                <div class='col-md-12 input-group' style='padding-left: 0px;'>
                    <input style='width: 75%' class='form-control quantity-input text-right' required placeholder='Enter Quantity' min='0' name='Quantity[]' type='number' step='1.00'>
                    <span style='width: 25%;' class='uom'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $data->UOM()->Abbreviation }}</span>
                </div>
            </div>
        </div>
    </td>
    <td style="vertical-align: middle;"><a id="{{ $data->UniqueID }}" class="alert-link" data-toggle="collapse" rel="{{ $data->UniqueID }}"><i class="nav-icon fa fa-trash-alt details"></i></a></td>
</tr>
<script>
    $('#{{ $data->UniqueID }}').on('click', function () {
        var uniqueID = $(this).attr('rel');
        alert(uniqueID);
    });


    var deptID = $('.department-select').select2('data')[0].id;
    $('.glcode-select').select2({
        ajax: {
            url: '/rs/gl-data/expense/'+deptID,
            dataType: 'json'
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        },
        matcher: matchCustom,
        placeholder: 'Select GL Code'
    });

    function matchCustom(params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
            return data;
        }

        // Do not display the item if there is no 'text' property
        if (typeof data.text === 'undefined') {
            return null;
        }

        // `params.term` should be the term that is used for searching
        // `data.text` is the text that is displayed for the data object
        if (data.text.indexOf(params.term) > -1) {
            var modifiedData = $.extend({}, data, true);
            modifiedData.text += ' (matched)';

            // You can return modified objects from here
            // This includes matching the `children` how you want in nested data sets
            return modifiedData;
        }

        // Return `null` if the term should not be displayed
        return null;
    }
</script>