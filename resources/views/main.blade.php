<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="{{ URL::asset('js/app.js') }}"></script>
    <title>Главная</title>
</head>
<body>
    <div class="container pt-5">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#import" role="tab" aria-controls="import" aria-selected="true">Импорт статей</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  data-toggle="pill" href="#search" role="tab" aria-controls="search">Поиск</a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="import" role="tabpanel" aria-labelledby="import">

                        <div class="input-group mb-5">
                            <div class="form-outline col-md-4">
                                <input placeholder="Введите ключевое слово" type="search" id="copyInput" class="form-control" />
                            </div>
                            <button id="copyBtn" type="button" class="copyBtn btn btn-primary ml-2" data-mdb-ripple-init>Скопировать</button>
                            <div class="d-lg-none spinner-border text-primary ml-3" id="spinner" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>

                        <div id="resultImport" class="mw-60">

                        </div>

                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>Название статьи</th>
                                <th>Ссылка</th>
                                <th>Размер статьи</th>
                                <th>Количество слов</th>
                            </tr>
                            </thead>
                            <tbody id="tableBody"></tbody>
                        </table>

                    </div>
                    <div class="tab-pane fade" id="search" role="tabpanel" aria-labelledby="search">
                        <div class="input-group mb-4">
                            <div class="form-outline col-md-4">
                                <input placeholder="Введите ключевое слово" type="search" id="searchInput" class="form-control" />
                            </div>
                            <button id="searchBtn" type="button" class="btn btn-primary ml-2">Найти</button>
                        </div>
                        <div class="row">
                            <ul id="resultSearch" class="col-mb-auto">

                            </ul>
                            <div id="articleContent" class="col ml-5 mr-3 py-2">

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
