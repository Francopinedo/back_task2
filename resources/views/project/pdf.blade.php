<html>
<head>
  <style>
    body {
      font-family: Helvetica;
      font-size: 12px;
    }

    @page {
      margin: 30px 30px 30px 30px;
    }

    header {
      font-size: 12px;
      left: 0px;
      height: 150px;
      top: -0px;
      right: 0px;
    }

    .page:after {
      content: counter(page);
    }

    .main {
      position: relative;
      top: 70px;
    }


    .detail_table thead tr:first-child th {
      border-bottom: 1px solid black;
      border-top: 1px solid black;
    }

    .detail_table{
      border-bottom: 1px solid black;
    }

    .detail_table tfoot {
      border: 0px solid black;
    }

    .detail_table tbody {
      border-bottom: 1px solid black;
      border-top: 1px solid black;
    }

    span.page-break {
      page-break-inside: auto;
    }

    .bordered, .bordered th {
      border-bottom: 1px solid #000000;
    }

    #cabecera{
      width: 100%;
      display: flex;
      flex-direction: nowrap;
    }

    #cabecera .seccion-projects{
      width: 50%;
      float: left;
    }

    #cabecera .seccion-contract{
      justify-content: space-between;
      width: 50%;
      float: right;
    }

    .title-encabezado{
      width: 30%;
      display: inline-block;
    }

    .title-response{
      width: 70%;
      display: inline-block;
    }

   .detail{
      height: 50px;
      width: 100%;
    }

    /* class works for table */
    /* table.page-break{
         page-break-before:always
     }*/
    /*tr.page-break  { display: block; page-break-before: auto; }*/

  </style>
</head>
<body>

  <header id="cabecera">
    <section class="seccion-projects">
      <h1>{{__('projects.project')}}</h1> <br><br>
      <section class="title-encabezado">
        <strong>{{__('projects.name_project')}}:</strong><br>
        <strong>{{__('projects.project_manager')}}:</strong><br>
        <strong>{{__('projects.start')}}:</strong><br>
        <strong>{{__('projects.end_date')}}:</strong><br>
        <strong>{{__('projects.sow_number')}}:</strong><br>
        <strong>{{__('projects.working_hours')}}:</strong><br>
        <strong>{{__('projects.status')}}:</strong>
      </section>
      <section class="title-response">
        <span>{{$project->name}}</span><br>

        @foreach($project_managers as $manager)
          @if($manager->id == $project->project_manager_id)
            <span width="75%">{{$manager->name}}</span><br>
          @endif
        @endforeach

        <span>{{ date('d-m-Y', strtotime( $project->start )) }}</span><br>
        <span>{{ date('d-m-Y', strtotime( $project->finish )) }}</span><br>
        <span>{{$project->sow_number}}</span><br>
        <span>{{$contract->workinghours_from}} - {{$contract->workinghours_to}}</span><br>
        <span>{{$project->status}}</span>

      </section>
    </section>

    <section class="seccion-contract">
      <h1>{{__('invoices.contract')}}</h1> <br><br>
      <section class="title-encabezado">
        <strong>{{__('projects.customer')}}:</strong><br>
        <strong>{{__('contracts.contract')}}#:</strong><br>
        <strong>{{__('contracts.amendment_number')}}:</strong><br>
        <strong>{{__('invoices.period')}}:</strong><br>
        <strong>{{__('projects.technical_director')}}:</strong><br>
        <strong>{{__('invoices.page')}}:</strong><br>
        <strong>{{__('invoices.date')}}:</strong><br>
      </section>
      <section class="title-response">
        <span>{{$project->customer_name}}</span><br>
        <span>{{$contract->sow_number}}</span><br>
        <span>{{$contract->amendment_number}}</span><br>
        <span>{{$contract->start_date}} - {{$contract->finish_date}}</span><br>

        @foreach($technical_directors as $directory)
          @if($directory->id == $project->technical_director_id)
            <span>{{$directory->name}}</span><br>
          @endif
        @endforeach

        <span class="page"></span><br>
        <span>{{ date('d-m-Y', strtotime( $contract->date )) }}</span><br>
      </section>
    </section>
  </header>

  <div class="main">
     <h1>{{__('invoices.other_data')}}</h1>

     <table width="100%" class="detail_table detail">
      <thead>
        <tr>
          <td width="25%"><strong>{{__('invoices.service_description')}}:</strong></td>
          <td width="75%">{{$contract->service_description}}</td>
        </tr>
      </thead>
    </table>

    <table width="100%" class="detail_table detail">
      <thead>
        <tr>
          <td width="25%"><strong>{{__('projects.engagement')}}:</strong></td>
          <td width="75%">{{$project->engagement}}</td>
        </tr>
      </thead>
    </table>

    <table width="100%" class="detail_table detail">
      <thead>
        <tr>
          <td width="25%"><strong>{{__('projects.identificator')}}:</strong></td>
          <td width="75%">{{$project->identificator}}</td>
        </tr>
      </thead>
    </table>

    <table width="100%" class="detail_table detail">
      <thead>
        <tr>
          <td width="25%"><strong>{{__('projects.presales_responsable')}}:</strong></td>
          <td width="75%">{{$project->presales_responsable}}</td>
        </tr>
      </thead>
    </table>

    <table width="100%" class="detail_table detail">
      <thead>
        <tr>
          <td width="25%"><strong>{{__('projects.technical_estimator')}}:</strong></td>
          <td width="75%">{{$project->technical_estimator}}</td>
        </tr>
      </thead>
    </table>

    <table width="100%" class="detail_table">

      <thead>
        <tr>
          <td width="25%"> <strong>{{__('projects.estimated_revenue')}}:</strong></td>
          <td width="75%">{{$project->estimated_revenue}}</td>
        </tr>
        <tr>
          <td width="25%"> <strong>{{__('projects.estimated_cost')}}:</strong></td>
          <td width="75%">{{$project->estimated_cost}}</td>
        </tr>
        <tr>
          <td width="25%"> <strong>{{__('projects.estimated_margin')}}:</strong></td>
          <td width="75%">{{$project->estimated_margin}}</td>
        </tr>
        <tr>
          <td width="25%"> <strong>{{__('projects.estimated_department_margin')}}:</strong></td>
          <td width="75%">{{$project->estimated_department_margin}}</td>
        </tr>
        <tr>
          <td width="25%"> <strong>{{__('projects.target_margin')}}:</strong></td>
          <td width="75%">{{$project->target_margin}}</td>
        </tr>
      <thead>

    </table>

    <span class="page-break"></span>
  </div>

</body>
</html>
