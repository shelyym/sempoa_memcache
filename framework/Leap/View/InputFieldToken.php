<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Leap\View;

/**
 * Description of InputFieldToken
 *
 * @author efindiongso
 */
class InputFieldToken extends Html {

    public $type;
    public $valueArray;
    public $labelArray;

    public function __construct($type, $id, $name, $valueArray, $labelArray, $value, $classname = 'tokenfield form-control') {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->classname = $classname;
        $this->value = stripslashes($value);
        $this->valueArray = $valueArray;
        $this->labelArray = $labelArray;
    }

    public function p() {
        $t = time();
        $sem = $this->type;
        $idku = $this->id . "_" . $t;
//        
//        pr($this->labelArray);
//        pr($this->valueArray);
        
     ?>
         <script>
var labelByID = {};
</script>  
         <?   
        $labelSemua = explode(",", $this->labelArray);
        $valueSemua = explode(",", $this->valueArray);
        $valueTerpakai = explode(",", $this->value);
        $valueSisa = array();
        $labelByID = array();
        foreach($valueSemua as $num=>$e){
           $e = trim(rtrim($e));
            
           if(!in_array($e, $valueTerpakai)) {
               $valueSisa[] = $e;
           }
           
           $labelByID[$e] = $labelSemua[$num];
           
           ?>
<script>
labelByID['<?=$e;?>'] = '<?=$labelSemua[$num];?>'
</script>    
           <?
        }
        
        
        
                    
        ?>
        <input type="<?= $sem; ?>" name="<?= $this->name; ?>" value="<?= $this->value; ?>" id="<?= $idku; ?>" class="<?= $this->classname; ?>" placeholder="Type something and hit enter" >

        <script>
            
            var data_yang_ada = [<?=$this->value;?>];
            var data_yang_tersisa = [<? if(count($valueSisa)>0)echo implode(",",$valueSisa);?>];
            
            var data_obj_terpakai = [];
            <?
                    foreach ($valueTerpakai as $id_pakai){
                        $id_pakai = trim(rtrim($id_pakai));
                        ?>
                           data_obj_terpakai.push({value: '<?=$id_pakai;?>', label: "<?=$labelByID[$id_pakai];?>"}); 
                            <?
                        
                    }
            
            ?>
            
            
            var data;
            var str = '<?= $this->labelArray; ?>';
            var label = new Array();
            label = str.split(",");
             var value = '<?= $this->valueArray; ?>';
            var arrValue = new Array();
            arrValue = value.split(",");
            var hasil = new Array();
            
//            
//            for (i = 0; i < label.length; i++) {
//                hasil[i] = {value: arrValue[i], label: label[i]}
//            }
            
            <?
            foreach($valueSisa as $sisaID){
                $sisaID = trim(rtrim($sisaID));
                ?>
                  hasil.push({value: '<?=$sisaID;?>', label: '<?=$labelByID[$sisaID];?>'});  
                    <?
            }
            ?>

console.log(data_obj_terpakai);
             console.log(hasil);

            $('#<?= $idku; ?>').tokenfield({
                autocomplete: {
                    source: hasil,
                    
                    //                    source: sourceValue,
        //                    source: [{value: "one", label: "Einz"}, {value: "two", label: "Zwei"}, {value: "three", label: "Drei"}],
                    //                      source:  [{ value: 'violet', label: 'Violet' }, { value: 'red', label: 'Red' }],  
                    delay: 100
                },
                showAutocompleteOnFocus: true
                
                            
            });
            
            $('#<?= $idku; ?>').tokenfield("setTokens",data_obj_terpakai);

$('#<?= $idku; ?>').on('tokenfield:createtoken', function (e) {
    
    var id_dipilih = e.attrs.value;
    for(var key in hasil){
        if(hasil[key].value == id_dipilih){
            hasil.splice(key, 1);
        }
    }
    console.log(hasil);
    $('#<?= $idku; ?>').data('bs.tokenfield').$input.autocomplete({source: hasil});
    
//    var data = e.attrs.value.split('|')
//    e.attrs.value = hasil[1] || hasil[0]
//    e.attrs.label = hasil[1] ? hasil[0] + ' (' + hasil[1] + ')' : hasil[0]
  });
  $('#<?= $idku; ?>').on('tokenfield:removedtoken', function (e) {
    var id_dipilih = e.attrs.value;
    hasil.push({value: id_dipilih, label: labelByID[id_dipilih]});
    $('#<?= $idku; ?>').data('bs.tokenfield').$input.autocomplete({source: hasil});
  });
//            $('#<?= $idku; ?>').on('tokenfield:createtoken', function (event) {
//                var existingTokens = $(this).tokenfield('getTokens');
//                $.each(existingTokens, function (index, token) {
//                    if (token.value === event.attrs.value)
//                        event.preventDefault();
//                });
//            });
        </script>

        <?
    }

}
