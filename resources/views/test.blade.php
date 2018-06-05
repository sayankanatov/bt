<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Таблица сотрудников</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
<body>
    <div class="container-fluid">
      <div class="row">
    <div class="col-md-12">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="/">Таблица руководителей</a>
        </li>
      </ul>
      @if(!empty($kindergartens))
      <table class="table">
        <thead>
          <tr>
            <th>
              
            </th>
            <th>
              
            </th>
            <th>
              Роли
            </th>
            <th>
              
            </th>
            <th>
              
            </th>
            <th>
              
            </th>
          </tr>
          <tr>
            <th>
              
            </th>
            <th>
              
            </th>
            <th>
              II
            </th>
            <th>
              
            </th>
            <th>
              
            </th>
            <th>
              
            </th>
          </tr>
          <tr>
            <th>
              Отдел
            </th>
            <th>
              
            </th>
            <th>
              Руководители
            </th>
            <th>
              
            </th>
            <th>
              
            </th>
            <th>
              
            </th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th>
              Название
            </th>
            <th>
              Категория
            </th>
            <th>
              #
            </th>
            <th>
              ФИО
            </th>
            <th>
              ID(номер сотового)
            </th>
            <th>
              
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($kindergartens as $key => $kindergarten)
          <tr>
            <td>
              {{$kindergarten->name}}
            </td>
            <td>
              {{++$key}}
            </td>
            @if(!empty($kindergarten_users))
            @foreach($kindergarten_users as $kindergarten_user)
              @if($kindergarten->name == $kindergarten_user->kindergarten->name)
              
                  @foreach($user_roles as $key => $role)
                    @if($role->user_id == $kindergarten_user->user->id)
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>{{$kindergarten_user->user->name}}</td>
                      <td>{{$kindergarten_user->user->number}}</td>
                    </tr>
                    @endif
                  @endforeach
                
              @endif
            @endforeach
            @endif
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td>Общее количество человек:</td>
            <td>{{$user_roles->count()}}</td>
          </tr>
        </tfoot>
      </table>
      @endif
    
       <a id="modal-769746" href="#modal-container-769746" role="button" class="btn" data-toggle="modal">Add kindergarten</a>
      
      <div class="modal fade" id="modal-container-769746" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel">
                Add
              </h5> 
              <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form role="form" method="post">
                @csrf
                <div class="form-group">
                   
                  <label for="exampleInputKinderGarten">
                    Kindergarten name
                  </label>
                  <input type="text" class="form-control" id="exampleInputKinderGarten" name="name" />
                </div>
                <button type="submit" class="btn btn-primary">
                  Submit
                </button>
              </form>
            </div>
          </div>
          
        </div>
        
      </div>

      <a id="modal-779682" href="#modal-container-779682" role="button" class="btn" data-toggle="modal">Add user</a>
      
      <div class="modal fade" id="modal-container-779682" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel">
                Add User
              </h5> 
              <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form role="form" method="post">
                @csrf
                <div class="form-group">
                   
                  <label for="exampleInputUserEmail">
                    Email
                  </label>
                  <input type="email" class="form-control" id="exampleInputUserEmail" name="email" />
                  <label for="exampleInputUserName">
                    Username
                  </label>
                  <input type="text" class="form-control" id="exampleInputUserName" name="username" />
                  <label for="exampleInputUserTel">
                    Telephone
                  </label>
                  <input type="text" class="form-control" id="exampleInputUserTel" name="tel" />
                  @if(!empty($kindergartens))
                    <label for="sel1">Детский сад:</label>
                    <select class="form-control" id="kindergarten_select" name="kindergarten_select[]">
                      @foreach($kindergartens as $kindergarten)
                        <option value="{{$kindergarten->id}}">{{$kindergarten->name}}</option>
                      @endforeach
                    </select>
                  @endif
                  
                </div>
                <button type="submit" class="btn btn-primary">
                  Submit
                </button>
              </form>
            </div>
          </div>
          
        </div>
        
      </div>
      
    </div>

    </div>
      </div>
    </div>

</body>
</html>
@if(!empty($kindergarten_users)) <!-- first IF start -->
            @foreach($kindergarten_users as $kindergarten_user) <!-- first FOREACH start -->
              @if(!empty($kindergarten_user->kindergarten->name)) <!-- second IF start -->
                @if($kindergarten->name == $kindergarten_user->kindergarten->name) <!-- third IF start -->
                  @foreach($managers as $key => $manager) <!-- second FOREACH start -->
                    @if($manager->user_id == $kindergarten_user->user->id) <!-- forth IF start -->
                    
                      <td>{{$kindergarten_user->user->name}}</td>
                      <td>{{$kindergarten_user->user->number}}</td>

                    @endif <!-- forth IF end -->
                  @endforeach <!-- second FOREACH end -->
                @endif <!-- third IF end -->
              @endif <!-- second IF end -->
            @endforeach <!-- first FOREACH end -->
          @endif <!-- first IF end -->
