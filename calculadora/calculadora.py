def sumar(a,b):
    """Suma dos números y devuelve el resultado."""
    resultado = a + b
    print(f"{a} + {b} = {resultado}")
    return resultado

def restar(a,b):
    """Resta dos números y devuelve el resultado."""
    resultado = a - b
    print(f"{a} - {b} = {resultado}")
    return resultado


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
    print("Calculadora iniciada por desarrollador A en la rama suma-resta")
    while True:
        mostrar_menu()
        opcion = input("Ingrese el número de la operación que desea realizar: ")
        if opcion == '5':
            print("Saliendo de la calculadora. ¡Hasta luego!")
            break
        elif opcion in ['1', '2']:
            try:
                num1 = float(input("Ingrese el primer número: "))
                num2 = float(input("Ingrese el segundo número: "))
                if opcion == '1':
                    sumar(num1, num2)
                else:
                    restar(num1, num2)
            except ValueError:
                print("Entrada no válida. Por favor, ingrese números válidos.")
        else:
            print("Opción no válida. Por favor, seleccione una opción del menú.")


    


