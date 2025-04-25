import { AuthRepositoryImpl } from "../../../Data/repositories/AuthRepository";

const {login} = new AuthRepositoryImpl();
export const LoginAuthUseCase = async (correo: string, contrasena: string) => {
return await login(correo, contrasena);
}