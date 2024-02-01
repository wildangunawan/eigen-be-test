def calculate(matrix):
    first_diagnoal = []
    second_diagnoal = []

    N = len(matrix)
    i = 0

    for m in matrix:
        first_diagnoal.append(m[i])
        second_diagnoal.append(m[N - i - 1])

        i += 1

    return sum(first_diagnoal) - sum(second_diagnoal)


print(calculate([[1, 2, 0], [4, 5, 6], [7, 8, 9]]))