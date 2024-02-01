def longest(sentence: str):
    sentence = sentence.split(" ")
    terpanjang = sorted(sentence, key=len, reverse=True)[0]

    return str(len(terpanjang)) + " character(s)"

print(longest("Saya sangat senang mengerjakan soal algoritma"))