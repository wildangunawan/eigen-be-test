def reverse_string(string):
    # 1. Balikkan keseluruhan string
    reversed = string[::-1]

    # 2. Tambahkan angka yang di depan ke posisi akhir
    reversed += reversed[0]

    # 3. Ambil setelah angka saja (indeks 1)
    return reversed[1:]

print(reverse_string("NEGIE1")) # "EIGEN1"