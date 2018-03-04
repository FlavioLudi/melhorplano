<!DOCTYPE html>
<html ng-app="myApp">
    <head>
        <title>Melhor Plano</title>
        <!-- Angular -->
        <script src="/assets/lib/angular/angular.min.js"></script>
        <script src="/assets/js/controllers.js"></script>
        <!-- Bootstrap -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="/assets/css/style.css" rel="stylesheet">
    </head>
    <body>
          
        <!-- Plans -->
        <section id="plans" ng-controller="MyController">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 text-center" ng-repeat="(key, option) in plans_options">
                        <div class="panel panel-success panel-plan">
                            <div class="panel-heading">
                                <i ng-show="hasBbType(option.types)" class="fa fa-wifi"></i>
                                <i ng-show="hasTvType(option.types)" class="fa fa-desktop"></i>
                                <i ng-show="hasLlType(option.types)" class="fa fa-phone"></i>
                                <h3>Plano {{key +1}}</h3>
                            </div>
                            <div class="panel-body text-center">
                                <p>R$ <strong>{{option.total_value}}</strong></p>
                                <p><small>por mês</small></p>
                            </div>
                            <ul class="list-group text-center borderless">
                                <li class="list-group-item borderless" ng-repeat="name in option.names"><i class="fa fa-check"></i> {{name}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Plans -->

    </body>
</html>