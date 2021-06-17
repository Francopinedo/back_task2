<?php


function exchange($projectResource, $invoice_currency_exchange)
{

    // var_dump($invoice_currency_exchange);


    $totalrate = isset($projectResource->amount) ? $projectResource->amount : 0;
    $totalrate_cost = isset($projectResource->cost) ? $projectResource->cost : 0;


    $exhange_value_cost = isset($projectResource->exhange_value_cost) ? $projectResource->exhange_value_cost : null;

    //la moneda del recurso NO es dolar
    if (is_object($projectResource) && isset($projectResource->exhange_value) && $projectResource->exhange_value != null) {


        //la moneda de la factura NO es dolar
        if (is_object($invoice_currency_exchange)) {

            $totalrate = $totalrate * $projectResource->exhange_value;
            if ($invoice_currency_exchange->value > 0) {
                $totalrate = $totalrate / $invoice_currency_exchange->value;
            }


            $totalrate_cost = $totalrate_cost * $projectResource->exhange_value;
            if ($invoice_currency_exchange->value > 0) {
                $totalrate_cost = $totalrate_cost / $invoice_currency_exchange->value;
            }


        } else {//la mnoneda de la factura es dolar
            $totalrate = $totalrate / $projectResource->exhange_value;
            $totalrate_cost = $totalrate_cost / $projectResource->exhange_value;
        }

    } else { //la moneda del recurso es dolar

        //var_dump($invoice_currency_exchange);
        //la moneda de la factura NO es dolar
        if (is_object($invoice_currency_exchange)) {

            //  var_dump($invoice_currency_exchange);
            $totalrate = $totalrate * $invoice_currency_exchange->value;

            //  echo $totalrate." - ";
            $totalrate_cost = $totalrate_cost * $invoice_currency_exchange->value;


        } else {//la mnoneda de la factura es dolar

            $totalrate = $totalrate;
            $totalrate_cost = $totalrate_cost;
        }

    }


    if ($exhange_value_cost != null && $exhange_value_cost != '') {


        //la moneda del recurso NO es dolar
        if (is_object($projectResource) && isset($exhange_value_cost) && $exhange_value_cost != null) {
            //la moneda de la factura NO es dolar

            if (is_object($invoice_currency_exchange)) {


                $totalrate_cost = $totalrate_cost * $exhange_value_cost;
                if ($invoice_currency_exchange->value > 0) {
                    $totalrate_cost = $totalrate_cost / $invoice_currency_exchange->value;
                }


            } else {//la mnoneda de la factura es dolar

                if ($projectResource->exhange_value > 0) {
                    $totalrate_cost = $projectResource->cost / $projectResource->exhange_value;
                }
            }

        } else { //la moneda del recurso es dolar
            //la moneda de la factura NO es dolar
            if (is_object($invoice_currency_exchange)) {


                $totalrate_cost = $projectResource->cost * $invoice_currency_exchange->value;


            } else {//la mnoneda de la factura es dolar


                $totalrate_cost = $totalrate_cost;
            }

        }


    }


    return array('rate' => $totalrate, 'cost' => $totalrate_cost);



}