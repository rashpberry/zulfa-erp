var RW = (function () {
  function $(i) { return document.getElementById(i); }
  function esc(s) {
    return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c];
    });
  }
  function api(a, body) {
    return fetch('api.php?a=' + a, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(body) })
      .then(function (r) { return r.text(); }).then(function (t) {
        try { return JSON.parse(t); } catch (e) {
          throw new Error('api.php tidak mengembalikan JSON. Pastikan hosting menjalankan PHP dan api.php ada di folder yang sama.');
        }
      });
  }
  function detail(d) {
    var h = '';
    if (d.jurnal) h += '<b>Jurnal:</b><ol>' + d.jurnal.map(function (x) { return '<li>' + esc(x) + '</li>'; }).join('') + '</ol>';
    if (d.saldo) h += '<b>Saldo akhir:</b><br>' + Object.keys(d.saldo).map(function (k) { return esc(k) + ': ' + Number(d.saldo[k]).toLocaleString('id-ID'); }).join('<br>');
    if (d.input) h += '<b>Input:</b> ' + Object.keys(d.input).map(function (k) { return esc(k) + '=' + esc(d.input[k]); }).join(', ') + '<br>';
    if (d.hasil) h += '<b>Hasil:</b><br>' + esc(d.hasil).replace(/\n/g, '<br>');
    $('dt').innerHTML = h;
    $('dt').hidden = false;
  }
  function simpan(jenis, nama, ringkasan, data) {
    return api('save', { jenis: jenis, nama: nama, ringkasan: ringkasan, data: data }).then(function (r) {
      if (r.error) throw new Error(r.error);
      location.href = location.pathname + '?tersimpan=1#riwayat';
      return r;
    });
  }
  document.addEventListener('click', function (e) {
    var t = e.target, tb = $('rw');
    if (!tb || !t.dataset || !tb.contains(t)) return;
    if (t.dataset.d !== undefined) { try { detail(JSON.parse(t.dataset.d)); } catch (x) {} }
    if (t.dataset.x !== undefined && confirm('Hapus simulasi ini dari database?')) {
      api('delete', { id: +t.dataset.x }).then(function () { location.href = location.pathname + '#riwayat'; location.reload(); });
    }
  });
  return { simpan: simpan, muat: function () {} };
})();
