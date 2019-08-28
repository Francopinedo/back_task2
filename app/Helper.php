<?php


function procces_import($file)
{
    $array = array();
    $destinationPath = "app/public/temp/";
    $file->move(storage_path($destinationPath), $file->getClientOriginalName());

    $file_n = storage_path('app/public/temp/' . $file->getClientOriginalName());
    $file_o = fopen($file_n, "r");

    $i = 0;
    while (($data = fgetcsv($file_o, 200, ";")) !== FALSE) {


       /* if ($i == 0) {
            $cabeceras = array();
            foreach ($data as $c) {

                $cabeceras[] = $c;
            }
            //var_dump($cabeceras);
        }*/

      //  if ($i > 0) {

            $datoinsert = array();

            $j = 0;


           // foreach ($cabeceras as $key => $value) {

                //$datoinsert[$value] = $data[$j];
                //var_dump($datoinsert);

                $j++;
            //}

            foreach ($data as $datum){

                $datoinsert[] = $datum;
            }

            array_push($array, $datoinsert);
       // }
        $i++;
    }
    fclose($file_o);
    Storage::disk('public')->delete('temp/'. $file->getClientOriginalName());

    return $array;
}

?>