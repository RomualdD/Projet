angular.module('Inscription',[]).controller('inscriptioncontroller', ['$scope', function ($scope) {
  $scope.name = {
    model: '',
    regex: /^[a-zA-Z -]{1,20}$/
  };
  $scope.firstname = {
    model: '',
    regex: /^[a-zA-Z -]{1,20}$/
  };
  $scope.mail = {
    model: 'me@example.com',
    regex: /^[\w\-\.]+[a-z0-9]@[\w\-\.]+[a-z0-9]\.[a-z]{2,}$/
  };
  $scope.phone = {
    model: '',
    regex: /[0]{1}[0-9]{9}$/
  };
  $scope.birthday = {
    model: '',
    regex: /[0-9]{2}[/]{1}[0-9]{2}[/]{1}[0-9]{4}/
  };
}]);
