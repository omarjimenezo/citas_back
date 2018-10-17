<!doctype html>
    <html>
        <head>
            <meta charset="utf-8">
            <style type="text/css">
                #table{
                    border-color: red;
                    border: bold;
                }
                .divCustom{
                    border-style: solid;
                    border-width: 1.5px;
                    border-color: #E9E9E9;
                    font-family: Helvetica,Verdana;
                }
                
                #size1{
                    height: 500px;
                    width: 700px;
                }
                #size2{
                    height: 200px;
                    width: 600px;
                    margin-left: 40px;
                    margin-top: 40px;
                }
                #size3{
                    height: 100px;
                    width: 600px;
                    margin-left: 40px;
                    margin-top: 40px;
                }
        @page {
            margin-top: 15px;

        }
    </style>

            <title>Ficha de pago</title>
        </head>
        <body>
                <div name="mainDiv" class="divCustom" id="size1">
                    <table style="margin-left: 40px;margin-top: 20px;">
                        <caption><b> Ficha de pago </b></caption>
                        <tr>
                            <td>Fecha del pago: </td><td> {{$oProofPaymentResponse->PaymentDate}} </td>
                        </tr>
                            <td>precio: </td><td> $ {{$oProofPaymentResponse->CourseTotal}} </td>
                    </table>
                    <div class="divCustom" id="size2">
                        <table width="450">
                        <caption><b>Información del curso</b></caption>
                            <tr><td></td><td></td></tr>
                            <tr><td></td><td></td></tr>
                            <tr>
                                <td>Nombre del curso: </td><td style="text-align: center; width: 300px;">{{$oProofPaymentResponse->CourseName}}</td>
                            </tr>
                            <tr>
                                <td>Modelo: </td><td style="text-align: center;" > {{$oProofPaymentResponse->CourseModel}}</td>
                            </tr>
                            <tr>
                                <td>Versión: </td><td style="text-align: center;">{{$oProofPaymentResponse->CourseName}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="divCustom" id="size3">
                        <table width="450">
                            <caption><b>Información del pago</b></caption>
                                <tr><td></td><td></td></tr>
                                <tr><td></td><td></td></tr>
                                <tr>
                                    <td>Metodo de pago </td><td style="text-align: center;"> {{$oProofPaymentResponse->PaymentMethod}}</td>
                                </tr>
                        </table>
                    </div>
                </div>
        </body>
    </html>
    