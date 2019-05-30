# Tiket[dot][com] PHP Library


# TESTING

Untuk melakukan testing lakukan ```command``` berikut ini

```bash
composer run-script test
```

Atau menggunakan PHPUnit

```bash
vendor/bin/phpunit --verbose --coverage-text
```

# How to contribute

* Lakukan **FORK** code.
* Tambahkan **FORK** pada git remote anda

Untuk contoh commandline nya :

```bash
git remote add fork git@github.com:$USER/php-tiketdotcom.git  # Tambahkan fork pada remote, $USER adalah username GitHub anda
```

Misalkan :

```bash
git remote add fork git@github.com:johndoe/php-tiketdotcom.git
```

* Setelah FORK, buat feature ```branch``` baru dengan cara

```bash
git checkout -b feature/my-new-feature origin/develop 
```

* Lakukan pekerjaan pada repository anda tersebut. 
* Sebelum melakukan commit lakukan ```Reformat kode``` anda menggunakan sesuai [PSR-2 Coding Style Guide](https://github.com/odenktools/php-bca#guidelines)
* Setelah selesai lakukan commit

```bash
git commit -am 'Menambahkan fitur A..B..C..D'
```

* Lakukan ```Push``` ke branch yang telah dibuat

```bash
git push fork feature/my-new-feature
```

* Lakukan PullRequest pada GitHub, setelah pekerjaan anda akan kami review. Selesai.

## Guidelines

* Koding berstandart [PSR-2 Coding Style Guide](http://www.php-fig.org/psr/psr-2/)
* Pastikan seluruh test yang dilakukan telah pass, jika anda menambahkan fitur baru, anda diharus kan untuk membuat unit test terkait dengan fitur tersebut.
* Pergunakan [rebase](https://git-scm.com/book/en/v2/Git-Branching-Rebasing) untuk menghindari conflict dan merge kode
* Jika anda menambahkan fitur, mungkin anda juga harus mengupdate halaman dokumentasi pada repository ini.

# LICENSE

MIT License

Copyright (c) 2019 odenktools

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
