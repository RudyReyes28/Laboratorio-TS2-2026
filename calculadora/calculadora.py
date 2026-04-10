def sumar(a,b):
    return a + b

def restar(a,b):
    return a - b


def multiplicar(a,b):
    return a * b


def dividir(a,b):
    if b==0:
        raise ValueError("No se puede dividir por cero")
    return a / b

def mostrar_menu():
    print(("\n=============  CALCULADORA TS2 ============="))
    print("Seleccione una operación:")
    print("1. Sumar")
    print("2. Restar")
    print("3. Multiplicar")
    print("4. Dividir")
    print("5. Salir")
    print("============================================")


if __name__ == "__main__":
    print("Calculadora iniciada por desarrollador base en develop")
    mostrar_menu()


