query = ['bbb', 'ac', 'dz']
to_find = ['xc', 'dz', 'bbb', 'dz']

def count_apperance(query, to_find):
    result = []

    for q in query:
        result.append(to_find.count(q))

    return result

print(count_apperance(query, to_find))