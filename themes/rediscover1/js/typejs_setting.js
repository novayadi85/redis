(function($) {
var l = window.location;
var base_url = l.protocol + "//" + l.host + "/"; /** + l.pathname.split('/')[1]; */

if(base_url == 'http://173.254.63.28/~redisco7'){
  base_url += '/rediscover' 
}

  var nflTeams = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      identify: function(obj) { return obj.value; },
      prefetch: base_url + '/businesslocations',
      ttl: 0
    });

    function nflTeamsWithDefaults(q, sync) {
      if (q === '') {
        sync(nflTeams.get('Accounting'));
      }

      else {
        nflTeams.search(q, sync);
      }
    }

    nflTeams.clearPrefetchCache();
       nflTeams.initialize();

    $('#search-type-filter .typeahead').typeahead({
      minLength: 0,
      highlight: true
    },
    {
      name: 's-location',
      display: 'value',
      source: nflTeamsWithDefaults
    }); 
})(jQuery);