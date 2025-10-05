$(document).ready(() => {
   $('#province').on('change', function() {
      var province_id = $(this).val();
      $.ajax({
         url:'Controller/cart.php?act=get_district_province',
         method: 'post',
         data: {province_id: province_id},
         dataType: 'json',
         success: (res) => {
            $('#district').empty();

            res.forEach(district => {
               $('#district').append('<option value="' + district.district_id + '">' + district.name + '</option>');
            });
         }
      });
   })

   $('#district').on('change', function() {
      var district_id = $(this).val();
      $.ajax({
         url:'Controller/cart.php?act=get_wards_district',
         method: 'post',
         data: {district_id: district_id},
         dataType: 'json',
         success: (res) => {
            console.log(res);
            $('#wards').empty();

            res.forEach(wards => {
               $('#wards').append('<option value="' + wards.wards_id + '">' + wards.name + '</option>');
            });
         }
      });
   })
})