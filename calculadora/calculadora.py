def sumar(a,b):
    return a + b

def restar(a,b):
    return a - b


def multiplicar(a,b):
    """Multiplica dos números y devuelve el resultado."""
    resultado = a * b
    print(f" {a} por {b} = {resultado}")
    return resultado


def dividir(a,b):
    """Divide dos números y devuelve el resultado. Si el divisor es cero, lanza una excepción."""
    if b==0:
        raise ValueError("No se puede dividir por cero")
    resultado = round(a / b, 2)
    print(f" {a} dividido por {b} = {resultado}")
    return resultado

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
    print("Calculadora iniciada por desarrollador b en feature/multiplicacion-división")
    while True:
        mostrar_menu()
        opcion = input("Ingrese el número de la operación que desea realizar: ")
        if opcion == '5':
            print("Saliendo de la calculadora. ¡Hasta luego!")
            break
        elif opcion in ['3', '4']:
            try:
                num1 = float(input("Ingrese el primer número: "))
                num2 = float(input("Ingrese el segundo número: "))
                if opcion == '3':
                    multiplicar(num1, num2)
                else:
                    dividir(num1, num2)
            except ValueError:
                print("Entrada no válida. Por favor, ingrese números válidos.")
        else:
            print("Opción no válida. Por favor, seleccione una opción del menú.")


