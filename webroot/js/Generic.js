/** 
 * @author Daniel Marín <110100010111h@gmail.com> 
 * 
 * Función wrapper de la función HTML DOM getElementById(). 
 * 
 * @param {String} elementID - El ID del elemento a obtener.
 * @return {Element} Un objeto de elemento, que representa un elemento con el ID especificado.
 *                   Devuelve nulo si no existen elementos con dicho ID.
 */
function byId(elementID) {
	return document.getElementById(elementID);
}