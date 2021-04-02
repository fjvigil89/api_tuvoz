<div class="container">

<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
      <div class="panel-heading">Agregar archivos</div>
        <div class="panel-body">
          <form method="POST" action="{{ route('treatment.store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
            
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label class="col-md-4 control-label">name</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="name" >
              </div>

              <label class="col-md-4 control-label">desciption</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="desc" >
              </div>

              <label class="col-md-4 control-label">frase</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="phrase" >
              </div>

            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Nuevo Archivo</label>
              <div class="col-md-6">
                <input type="file" class="form-control" name="file" >
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">Enviar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>