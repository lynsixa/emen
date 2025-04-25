export interface User {
    documento?: string;
    tipoDocumento: string;
    nombre: string;  
    apellido: string;    
    direccion: string;
    localidad: string;
    telefono: number;    
    correo: string;  
    contrasena: string;
    confirmPassword: string;
    id_estado: number; 
    idrol: number;
    session_Token?: string;
}